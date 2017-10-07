from __init__ import app, api
from controller.Upload import Upload
import requests
import os

api.add_resource(Upload, '/upload/<bucket_name>')

@app.route('/', methods=['GET','POST'])
def verifica_server():
    return 'Hello Kabum'

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80, debug=True)
