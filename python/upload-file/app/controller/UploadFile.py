from flask_restful import Resource
from classe.Resize import Resize
from flask import request
import base64, random, time, uuid, os

class UploadSimples(Resource):
    def post(self):
        data = request.get_json()
        imgdata = base64.b64decode(data["arquivo"])
        filename = '/tmp/' + uuid.uuid4().hex + "-" + str(random.randint(1, 999999)) + "-" + str(int(time.time())) + ".jpg"  # arquivo
        with open(filename, 'wb') as f:
            f.write(imgdata)

        r = Resize()
        r.resizeImage(filename, '/tmp/new.jpg', 500)
        os.remove(filename)

        return filename
    def get(self):
        r = Resize()
        return r.resizeImage('/tmp/celular.jpg', '/tmp/new.jpg', 1200)
