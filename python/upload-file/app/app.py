import sys, os, math
sys.path.append(os.getcwd())
from __init__ import app, api
from controller.UploadFile import UploadSimples

@app.route("/")
def hello():
    return "Hello World!"

api.add_resource(UploadSimples, '/upload')

if __name__ == '__main__':
    app.run(debug=True)

if __name__ == '__main__':
    app.run(debug=True, use_reloader=True)