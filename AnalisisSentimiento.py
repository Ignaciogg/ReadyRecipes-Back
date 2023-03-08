# pip install textblob
# pip install googletrans==4.0.0-rc1

from textblob import TextBlob
from googletrans import Translator
from time import sleep



def Translate(texto):
	trans = Translator()
	trans_sen = trans.translate(texto,src='es',dest='en')
	sleep(0.1)
	return trans_sen.text


texto = 'La receta es muy mala'
traduccion = Translate(texto)

print(traduccion)

blob = TextBlob(traduccion)

sentimiento = blob.sentiment
print(sentimiento)