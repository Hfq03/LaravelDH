// Load our customized validationjs library
import Validator from '../validator'
 
// Submit form ONLY when validation is OK
const form = document.getElementById("create")
 
form.addEventListener("submit", function( event ) {
   // Reset errors messages
   // ...
   document.querySelector(".error").innerHTML = "";

   // Create validation
   let data = {
        "body": document.getElementsByName("body")[0].value,
        "upload": document.getElementsByName("upload")[0].value,
        "latitude": document.getElementsByName("latitude")[0].value,
        "longitude": document.getElementsByName("longitude")[0].value,
        "visibility_id": document.getElementsByName("visibility_id")[0].value,
   }
   let rules = {
        "body": "required",
        "upload": "required",
        "latitude": "required",
        "longitude": "required",
        "visibility_id": "required",
   }
   let validation = new Validator(data, rules)
   // Validate fields
   if (validation.passes()) {
       // Allow submit form (do nothing)
       console.log("Validation OK")
   } else {
       // Get error messages
       let errors = validation.errors.all()
       console.log(errors)
       // Show error messages
       for(let inputName in errors) {
           // ...
           let campo = document.querySelector('#'+inputName)

           campo.querySelector(".error").innerHTML=errors[inputName];
           campo.querySelector(".error").classList.remove("errorHidden");

       }
       // Avoid submit
       event.preventDefault()
       return false
   }
})
