# -*- coding: utf-8 -*

from flask_restful import Resource
from classe.Resize import Resize
from flask import request
import base64, random, time, uuid, os, json

class UploadSimples(Resource):
    def post(self):
        data = request.get_json()

        strHex = uuid.uuid4().hex

        imgdata = base64.b64decode(data["arquivo"])
        filename = '/tmp/' + strHex + "-" + str(random.randint(1, 999999)) + "-" + str(int(time.time())) + ".jpg"  # arquivo
        with open(filename, 'wb') as f:
            f.write(imgdata)

        r = Resize()

        retorno = data["size"]

        for tamanho in retorno:
            nome = strHex + "-"

            if "name" in tamanho:
                nome = ""
                if "begin" in tamanho["name"]:
                    nome = nome + tamanho["name"]["begin"] + "-"

                nome = nome + strHex + "-";

                if "end" in tamanho["name"]:
                    nome = nome + tamanho["name"]["end"] + "-"

            if "path" in tamanho:
                tamanho["path"] = tamanho["path"].replace('//', '/')

                if(tamanho["path"][0] == "/"):
                    tamanho["path"] = tamanho["path"][1:len(tamanho["path"])]

                if(tamanho["path"][ len(tamanho["path"])-1 ] == "/"):
                    tamanho["path"] = tamanho["path"][0:len(tamanho["path"])-1]

                tamanho["path"] = "/"+tamanho["path"]+"/"

            size = 0
            if "size" in tamanho:
                size = int(tamanho['size'])
                del(tamanho["size"])

            nome = nome[0:-1]
            if size > 0:
                nome = nome + "-" + str(size)
            nome = nome + tamanho["extension"]

            white = False
            if "white" in tamanho:
                white = tamanho["white"]
                del(tamanho["white"])

            if "path" in tamanho:
                if not os.path.exists("/tmp"+tamanho["path"]):
                    os.makedirs("/tmp"+tamanho["path"])
                nome = tamanho["path"] + nome
                del(tamanho["path"])

            r.resizeImage(filename, '/tmp/' + nome, size, white)
            tamanho["name"] = nome

            del(tamanho["extension"])

        os.remove(filename)

        return retorno

    def get(self):
        r = Resize()
        return r.resizeImage('/tmp/celular.jpg', '/tmp/new.jpg', 1200)
