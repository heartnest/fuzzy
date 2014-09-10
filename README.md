Fuzzy Search Map
===================
OpenStreetMaps does not support fuzzy search.

The aim of this project is to implement such algorithm which helps users correct their input.

In specific, we take streets in Bologna and those in Paris for example

Source of the Streets in Bologna: http://www.geoplan.it/cartine-mappa/mappe-regione-emilia_romagna

Source of the Streets in Paris: http://en.wikipedia.org/wiki/User:ThePromenader/Paris_street_list

we wrote ajax scripts which extract the street names from the source html and store them in json.

we run leventhtein distace algorithm to calculate the distance between input and street names in our database,
we then choose the name with lowest distance to be the adviced address.