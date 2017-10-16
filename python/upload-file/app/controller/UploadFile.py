from flask_restful import Resource
from classe.Resize import Resize

class UploadSimples(Resource):
        def get(self):
            r = Resize()
            return r.resizeImage('/tmp/celular.jpg', '/tmp/new.jpg', 1200)
