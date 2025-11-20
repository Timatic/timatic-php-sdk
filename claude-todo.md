Focus steeds op een enkele hoofdtaak. Als deze klaar is geef dan de gelegenheid om feedback te geven en de resultaten te committen. 

2. De classes moeten een {modelName}Id parameter hebbben.

- Hiervoor moeten we de openapi spec file verbeteren. 
- Vermoedelijk door scramble te gebruiken in Timatic API

8. Documentation Updates

- Update README.md met alle nieuwe features
- Voeg voorbeelden toe voor:
- Pagination usage
- Custom response methods
- Configuration options
- Update regenerate instructies met nieuwe patterns


11. Vereenvoudig de filters voor de collection requests

- Verwijder de filters uit de constructor van de collection request classes
- Bekijk de implementatie van de filters in de intermax/api-client package
- Voeg een filter() method toe aan de collection request classes in de generator
- Update README.md met nieuwe filter instructies
