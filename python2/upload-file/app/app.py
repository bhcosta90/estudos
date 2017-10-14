import sys, os, math
sys.path.append(os.getcwd())
from flask import jsonify
from __init__ import app, api
from controller.UploadFile import HelloWorld

@app.route("/")
def hello():
    return "Hello World!"

api.add_resource(HelloWorld, '/upload')

if __name__ == '__main__':
    app.run(debug=True)

if __name__ == '__main__':
    app.run(debug=True, use_reloader=True)