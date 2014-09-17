Fuzzy Search Map
===================
OpenStreetMaps does not support fuzzy search.

The aim of this project is to implement such algorithm which helps users correct their input.

In specific, we take streets in Bologna and those in Paris for example

Source of the Streets in Bologna: http://www.geoplan.it/cartine-mappa/mappe-regione-emilia_romagna

Source of the Streets in Paris: http://en.wikipedia.org/wiki/User:ThePromenader/Paris_street_list

we wrote ajax scripts which extract the street names from the source html and store them in json.

we run levenshtein distance algorithm to calculate the distance between input and street names in our database,
we then choose the name with lowest distance to be the adviced address.


Proposed lev distance algorithm for address
-----------
A general levenshtein distance between 2 address strings usually does not give a correct address result.

In this project we split address strings in more components,
calculate distance for each one and take the smallest value,
then sum up these distances as the final distance btw input string and address string in database.



Testing
-----------
In the test we search "viale alfredo orianle 16"

Matched:
- oriani 16 (single letter)
- via oriani 16 (wrong road type)
- viale alfredo oriani 16 (different words order)
- viale oriani alfredo 16 (different words order)
- viale alFreDO oRIanI 16 (upper case)
- ViAle OriNa 16 (upper case)
- viale alfredo    oriani 16 (more space)
- viale alfredo zz oriani 16 (extra words in middle)
- viale qq alfredo zz qq oriani 16  (more extra words in middle)
- viale alfredo,oriani 16 (one word)
- viale alfredoa orianai 16 (suffix)
- viale alfreio orieni 16 (less substitutions)
- viale alfredooriani 16 (concatenated)
- viale  zzz alfredo zzz 16 (one word in the phrase)
- viale zzz oriani zzz 16 (one word in the phrase)
- viale elafedo irnoia 16 (more substitution)


Not Matched:
- via elzgedo irapia 16  (more substitution)
- zzzzzz


issues(cannot find, solved on 17 sep):
- via giuseppe massarenti
- possible reason, osm encoded these names with different format or order, so it could not return a valid coordinate.


Relevant refs:
-----------
- match patterns
- http://stackoverflow.com/questions/5859561/getting-the-closest-string-match
- weighting levenshtein:
- http://stackoverflow.com/questions/7367410/using-levenshtein-to-match-target-string-extra-text
- API OSM:
- http://wiki.openstreetmap.org/wiki/Nominatim
