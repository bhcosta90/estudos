# coding=utf-8
import json
from flask.views import MethodView
from flask import request
import os
import shutil
import time
import math
from PIL import Image
from boto3 import client

class Upload(MethodView):
    def getDictArray(self, post, name):
        dic = {}
        for k in post.keys():
            if k.startswith(name):
                rest = k[len(name):]

                # split the string into different components
                parts = [p[:-1] for p in rest.split('[')][1:]
                print (parts)
                id = int(parts[0])

                # add a new dictionary if it doesn't exist yet
                if id not in dic:
                    dic[id] = {}

                # add the information to the dictionary
                dic[id][parts[1]] = post.get(k)
        return dic

    def extension(self, extension, type):
        if type == '':
            return extension
        elif type=='image/png':
            return '.png'
        elif type=='image/gif':
            return '.gif'
        elif type=='image/jpg':
            return '.jpg'

        return extension

    def get(self):
        return 'Hello KaBuM!'

    def resize_canvas(self, old_image_path, new_image_path, canvas_width=500, canvas_height=500):
        #   curl -X POST \
        #   http://localhost/upload \
        #   -H 'cache-control: no-cache' \
        #   -H 'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW' \
        #   -H 'postman-token: a8edf0e8-9836-c97f-9f28-1b70fa9f4460' \
        #   -F arquivo=@Rainbow.png \
        #   -F path=/produtos/fotos/1500/ \
        #   -F type=image/jpg \
        #   -F 'imagem[0][width]=500' \
        #   -F 'imagem[0][height]=500' \
        #   -F 'imagem[0][type]=jpg' \
        #   -F 'imagem[0][name]=g' \
        #   -F 'imagem[0][branco]=0'

        im = Image.open(old_image_path)
        old_width, old_height = im.size

        # Center the image
        x1 = int(math.floor((canvas_width - old_width) / 2))
        y1 = int(math.floor((canvas_height - old_height) / 2))

        mode = im.mode

        if len(mode) == 1:  # L, 1
            new_background = (255)
        if len(mode) == 3:  # RGB
            new_background = (255, 255, 255)
        if len(mode) == 4:  # RGBA, CMYK
            new_background = (255, 255, 255, 255)

        newImage = Image.new(mode, (canvas_width, canvas_height), new_background)
        newImage.paste(im, (x1, y1, x1 + old_width, y1 + old_height))
        newImage.save(new_image_path)
        return 1

    def post(self, bucket_name):
        tmp_arquivo = ''
        tamanho = []
        if not 'path' in request.form:
            return "Necessário enviar a variável 'path'", 404
        else:
            path = request.form['path']
            if not os.path.exists("/tmp/" + path):
                os.makedirs("/tmp/" + path)

        file_extension = ''
        if(request.files):
            if (request.files['arquivo'].filename):
                file = request.files['arquivo'];
                file.save(os.path.join("/tmp/", file.filename))
                tmp_arquivo = "/tmp/" + file.filename
                filename, file_extension = os.path.splitext('/tmp/' + file.filename)

        if(tmp_arquivo):
            im = Image.open(tmp_arquivo)

            tamanho_width_original = im.size[0]
            tamanho_height_original = im.size[1]

            tamanho.append({
                "quality": 100,
                "height": {"foto": tamanho_height_original, "branco": 0},
                "width": {"foto": tamanho_width_original, "branco": 0},
                "name": "original" + file_extension,
                "branco": 0,
                "path": path,
            })

            images = self.getDictArray(request.form, 'imagem')

            for i in images:
                filename, file_extension = os.path.splitext('/tmp/' + file.filename)
                width_imagem   = int(images[i]['height'])
                height_imagem  = int(images[i]['width'])

                if(tamanho_width_original > tamanho_height_original):
                    fator = tamanho_width_original / tamanho_height_original
                    largura = width_imagem
                    altura = int(largura / fator)
                elif(tamanho_height_original > tamanho_width_original):
                    fator = tamanho_height_original / tamanho_width_original
                    altura = height_imagem
                    largura = int(altura / fator)
                else:
                    altura = height_imagem
                    largura = width_imagem

                if largura > tamanho_width_original:
                    largura = tamanho_width_original

                if altura > tamanho_height_original:
                    altura = tamanho_height_original

                branco = 0
                if 'branco' in images[i]:
                    if images[i]["branco"]==1:
                        branco = 1

                tamanho.append({
                    "height": {"foto": altura, "branco": height_imagem},
                    "width": {"foto": largura, "branco": width_imagem},
                    "quality": 100,
                    "name": str(i) + '_' + str(int(time.time())) + '_' + str(altura) + "x" + str(largura) + "_" +images[i]['name'] + file_extension,
                    "path": path,
                    "branco": branco
                })

            for valor in tamanho:
                size = valor["width"]["foto"], valor["height"]["foto"]

                im.thumbnail(size)
                im.save("/tmp" + valor["path"] + valor["name"], quality=valor["quality"])

                if valor["height"]["branco"] > 0 and valor["width"]["branco"] and valor["branco"] == 1:
                    self.resize_canvas("/tmp" + valor["path"] + valor["name"], "/tmp" + valor["path"] + valor["name"], valor["width"]["branco"], valor["height"]["branco"]);

                valor['height'] = valor['height']['foto']
                valor['width'] = valor['width']['foto']
                valor['path_phisical'] = "/tmp" + valor["path"] + valor["name"]
                del (valor["quality"])

            s3_client = client(
                service_name='s3',
                endpoint_url='http://fakes3:4567',
                region_name='',
                aws_access_key_id='',
                aws_secret_access_key=''
            )

            os.remove("/tmp/" + file.filename)
            for valor in tamanho:
                s3_client.upload_file(valor["path_phisical"], bucket_name, valor["path"] + valor["name"])

                valor["url"]    = "http://fakes3:4567/"
                valor["name"]   = valor["name"]
                valor["uri"]    = valor["path"]
                valor["name"]   = valor["name"]
                del (valor["height"])
                del (valor["width"])
                del (valor["path"])
                del (valor["path_phisical"])
                del (valor["branco"])

        else:
            return "Necessário enviar o arquivo com a variável 'arquivo'", 404

        return tamanho
