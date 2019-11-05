    function validateName(x){
      // Validation rule
      var reg = /[A-Za-z -']$/;
      // Check input
      if(reg.test(document.getElementById(x).value)){
        // Style green
        document.getElementById(x).style.background ='#ccffcc';
        // Hide error prompt
        document.getElementById(x + 'Error').style.display = "none";
        return true;
      }else{
        // Style red
        document.getElementById(x).style.background ='#e35152';
        // Show error prompt
        document.getElementById(x + 'Error').style.display = "block";
        return false; 
      }
    }
    // Validate email
    function validateEmail(email){ 
      var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if(reg.test(email)){
        document.getElementById('email').style.background ='#ccffcc';
        document.getElementById('emailError').style.display = "none";
        return true;
      }else{
        document.getElementById('email').style.background ='#e35152';
        return false;
      }
    }

    // validate int range
    function validateIntRange(x, min, max){
      if(isNaN(x) || x < min || x > max){
        document.getElementById(x).style.background = "#e35152";
        document.getElementById(x + "Error").style.display = "block";
        return false;
      } else {
        document.getElementById(x).style.background = "#ccffcc";
        document.getElementById(x).style.display = "none";
        return true;
      }
    }

    // validate string length
    function validateStringLength(x, min, max){
      if(typeof(x) === "string" && x.length > 2 && x.length < 255){
        document.getElementById(x).style.background = "#e35152";
        document.getElementById(x + "Error").style.display = "block";
        return false;
      } else {
        document.getElementById(x).style.background = "#ccffcc";
        document.getElementById(x + "Error").style.display = "none";
        return true;
      }
    }

    // Validate Select boxes
    function validateSelect(x){
      if(document.getElementById(x).selectedIndex !== 0){
        document.getElementById(x).style.background ='#ccffcc';
        document.getElementById(x + 'Error').style.display = "none";
        return true;
        }else{
        document.getElementById(x).style.background ='#e35152';
        return false; 
      }
    }
    function validateRadio(x){
      if(document.getElementById(x).checked){
        return true;
      }else{
        return false;
      }
    }
    function validateCheckbox(x){
      if(document.getElementById(x).checked){
        return true;
      }
      return false;
    }   
    function validateForm(){
      // Set error catcher
      var error = 0;
      // Check name
      if(!validateName('name')){
        document.getElementById('nameError').style.display = "block";
        error++;
      }
      // Validate email
      if(!validateEmail(document.getElementById('email').value)){
        document.getElementById('emailError').style.display = "block";
        error++;
      }

      // validate age
      if(!validateIntRange('age')){
        document.getElementById('ageError').style.display = "block";
        error++;
      }

      // Validate animal dropdown box
      if(!validateSelect('category')){
        document.getElementById('categoryError').style.display = "block";
        error++;
      }
      // Validate Radio
      if(validateRadio('male')){
 
      }else if(validateRadio('female')){
         
      }else{
        document.getElementById('genderError').style.display = "block";
        error++;
      }
      if(!validateCheckbox('accept')){
        document.getElementById('termsError').style.display = "block";
        error++;
      }
      // Don't submit form if there are errors
      if(error > 0){
        return false;
      }
    }