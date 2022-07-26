let requestURL = "reg.php";
let user = document.forms.myForm;
let method = "POST";
let headers = { "Content-Type": "application/json" };

function sendRequest(method, requestURL, user) {
   return fetch(requestURL, {
      method: method,
      user: JSON.stringify(user),
      headers: headers,
   }).then((Response) => {
      return Response.json();
   });
}

sendRequest(method, requestURL, user)
   .then((data) => console.log(data))
   .catch((err) => console.log(err));
