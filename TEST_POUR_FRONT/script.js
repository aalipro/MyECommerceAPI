// import { Request } from "./Request";

// function querySparql(query) {
//     return new Promise((resolve, reject) => {
//       const xhr = new XMLHttpRequest();
//       const url = 'https://query.wikidata.org/sparql';
//       const params = 'query=' + encodeURIComponent(query);
  
//       xhr.open('GET', url + '?' + params, true);
//       xhr.setRequestHeader('Accept', 'application/sparql-results+json');
  
//       xhr.onload = function () {
//         if (xhr.status >= 200 && xhr.status < 300) {
//           const response = JSON.parse(xhr.responseText);
//           resolve(response);
//         } else {
//           reject(new Error('Error: ' + xhr.status));
//         }
//       };
  
//       xhr.onerror = function () {
//         reject(new Error('Request failed'));
//       };
  
//       xhr.send();
//     });
//   }
  
//   // Example SPARQL query to retrieve images associated with an entity
//   const entityId = 'Q42'; // Wikidata entity ID
//   const sparqlQuery = `
//   SELECT ?image
//   WHERE {
//     wd:${entityId} wdt:P18 ?image.
//   }
//   `;
  
//   // Call the querySparql function with the SPARQL query
  

// function testQuery(){
//     querySparql(sparqlQuery)
//     .then(data => {
//       // Process the results
//       const results = data.results.bindings;
//       results.forEach(result => {
//         const imageUrl = result.image.value;
//         console.log(imageUrl);
//       });
//     })
//     .catch(error => {
//       // Handle errors
//       console.error('An error occurred:', error);
//     });
// }

// function testGet(){
//     const url = "https://projets.iut-orsay.fr/prj-prism/BACK%20_ALIAS/routeur.php?objet=Client&action=lireObjets";
//     Request.get(url)
//         .then(response =>{
//             console.log(response)
//         })
// }
alert("On est là!!!")