from flask_restful import Resource
import math
from PIL import Image

class HelloWorld(Resource):
    def get(self):

        im = Image.open('/tmp/teste.png')
        old_width, old_height = im.size
        canvas_width = 500
        canvas_height = 500

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
        newImage.save('/tmp/new.png')
        return {}