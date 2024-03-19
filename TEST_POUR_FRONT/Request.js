 class Request {
    static get(url) {
      return Request.sendRequest('GET', url);
    }
  
    static post(url, data) {
      return Request.sendRequest('POST', url, data);
    }
  
    static delete(url) {
      return Request.sendRequest('DELETE', url);
    }
  
    static sendRequest(method, url, data) {
      return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
  
        xhr.open(method, url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
  
        xhr.onload = function () {
          if (xhr.status >= 200 && xhr.status < 300) {
            const response = JSON.parse(xhr.responseText);
            resolve(response);
          } else {
            reject(new Error('Error: ' + xhr.status));
          }
        };
  
        xhr.onerror = function () {
          reject(new Error('Request failed'));
        };
  
        if (data) {
          xhr.send(JSON.stringify(data));
        } else {
          xhr.send();
        }
      });
    }
  }
  
  // Exemple d'utilisation de la classe Request pour effectuer des requêtes
  
  // Requête GET
//   Request.get('https://api.example.com/data')
//     .then(response => {
//       console.log('GET response:', response);
//     })
//     .catch(error => {
//       console.error('An error occurred:', error);
//     });
  
//   // Requête POST
//   const postData = { name: 'John', age: 30 };
//   Request.post('https://api.example.com/users', postData)
//     .then(response => {
//       console.log('POST response:', response);
//     })
//     .catch(error => {
//       console.error('An error occurred:', error);
//     });
  
//   // Requête DELETE
//   Request.delete('https://api.example.com/users/123')
//     .then(response => {
//       console.log('DELETE response:', response);
//     })
//     .catch(error => {
//       console.error('An error occurred:', error);
//     });
alert("REQUEST")
function testGet(){
    const url = "https://projets.iut-orsay.fr/prj-prism/BACK%20_ALIAS/routeur.php?objet=Client&action=lireObjets";
    Request.get(url)
        .then(response =>{
            console.log(response)
        })
}