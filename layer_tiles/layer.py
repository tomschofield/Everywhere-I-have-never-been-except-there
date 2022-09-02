# Importing Image module from PIL package
from PIL import Image
import requests
from io import BytesIO

url1 = "http://localhost:9999/map_server/tiles.php/13/2723/4096"
response1 = requests.get(url1)
im1 = Image.open(BytesIO(response1.content))#.convert('P')


url2 = "http://localhost:9999/map_server/tiles.php/13/2721/4104"
response2 = requests.get(url2)
im2 = Image.open(BytesIO(response2.content))#.convert('P')

url3 = "http://localhost:9999/map_server/tiles.php/9/169/255"
response3 = requests.get(url3)
mask = Image.open(BytesIO(response3.content)).convert('L')


# compositing all the three images
im3 = Image.composite(im1, im2, mask)

# to show specified image
im3.show()

