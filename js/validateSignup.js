function validateform() {
  let form = document.forms["newaccount"];
  let username = form["username"].value;
  let email = form["email"].value;
  let password = form["password"].value;
  let password2 = form["password2"].value;

  if (
    validateEmail(email) &&
    validateName(username) &&
    validatePassword(password) &&
    validatePasswordMatch(password, password2)
  ) {
    return true;
  } else {
    let error = "";

    if (!validateEmail(email)) {
      error += "Felaktig email: Det måste vara en giltig universitetsmail\n";
    }
    if (!validateName(username)) {
      error += "Felaktigt användarnamn: Det måste vara minst 3 tecken långt\n";
    }
    if (!validatePassword(password)) {
      error += "Felaktigt lösenord: Det måste vara minst 8 tecken långt\n";
    }
    if (!validatePasswordMatch(password, password2)) {
      error += "Felaktigt lösenord: Lösenorden måste vara identiska\n";
    }

    alert(error);
  }
}

function validateEmail(email) {
  let emailArr = [
    "uu.se",
    "su.se",
    "kth.se",
    "lu.se",
    "uma.se",
    "jo.se",
    "ki.se",
    "slu.se",
    "li.se",
    "mit.se",
  ];
  let sliced = email.slice(email.indexOf("@") + 1, email.length);

  if (
    email.lastIndexOf(".") > email.indexOf("@") + 1 &&
    email.indexOf("@") > 0 &&
    email.length - email.lastIndexOf(".") > 1 &&
    emailArr.includes(sliced)
  ) {
    return true;
  }
  return false;
}

function validateName(username) {
  if (username.trim().length > 2) {
    return true;
  }
  return false;
}
/* bör utöka valideringen av pw*/
function validatePassword(password) {
  if (password.length > 7) {
    return true;
  }
  return false;
}

function validatePasswordMatch(password, password2) {
  if (password == password2) {
    return true;
  }
  return false;
}
