

const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

// Add the "right-panel-active" class initially to show sign-up on the right
// container.classList.add("right-panel-active");

const all = document.getElementsByName("a");


signUpButton.addEventListener('click', () => {
  container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
  container.classList.remove("right-panel-active");
});

