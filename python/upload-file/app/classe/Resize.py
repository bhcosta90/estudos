import math
from PIL import Image

class Resize:
    def resizeImage(self, image, imageNew, tamanho):
        im = Image.open(image)
        old_width, old_height = im.size

        if old_width > tamanho:
            old_width = tamanho

        if old_height > tamanho:
            old_height = tamanho

        if old_height > old_width and old_height > tamanho:
            new_height = tamanho
            new_width = (old_width * new_height) / old_height
        elif old_width > old_height and old_width > tamanho:
            new_width = tamanho
            new_height = (old_height * new_width) / old_width
        elif old_height > tamanho:
            new_width = old_width
            new_height = tamanho
        elif old_height > tamanho:
            new_width = tamanho
            new_height = old_height
        elif old_height > tamanho and old_height > tamanho:
            new_width = tamanho
            new_height = tamanho
        else:
            new_width = old_width
            new_height = old_height

        im = im.resize( (int(new_width), int(new_height)), Image.ANTIALIAS )
        im.save(imageNew)
        self.imageToWhite(imageNew, imageNew, tamanho)

        return imageNew

    def imageToWhite(self, image, imageNew, tamanho):
        im = Image.open(image)
        old_width, old_height = im.size

        canvas_width = tamanho
        canvas_height = tamanho

        # Center the image
        x1 = int(math.floor((canvas_width - old_width) / 2))
        y1 = int(math.floor((canvas_height - old_height) / 2))

        mode = im.mode
        new_background = False
        if len(mode) == 1:  # L, 1
            new_background = (255)
        if len(mode) == 3:  # RGB
            new_background = (255, 255, 255)
        if len(mode) == 4:  # RGBA, CMYK
            new_background = (255, 255, 255, 255)

        newImage = Image.new(mode, (canvas_width, canvas_height), new_background)
        newImage.paste(im, (x1, y1, x1 + old_width, y1 + old_height))
        newImage.save(imageNew)
        return 1