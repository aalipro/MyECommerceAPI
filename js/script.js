let xhr = new XMLHttpRequest();

var url= 	url = "https://projets.iut-orsay.fr/prj-prism/BACK/routeur.php?objet=Utilisateur&action=seConnecter&mail=alias@gmail.com&mdp=alias";
xhr.open("GET",url, true);
var resultat = JSON.parse(xhr.responseText);
alert("Salut")
console.log(resultat)