document.addEventListener('DOMContentLoaded', function() {
  const signupLink = document.querySelector('.signup-link');
  const loginLink = document.querySelector('.login-link');
  const loginContent = document.querySelector('.login-content');
  const signupContent = document.querySelector('.signup-content');
  const forgotPasswordLink = document.querySelector('.forgot-password');
  const forgotPasswordContent = document.querySelector('.forgot-password-content');

  // Hide the signup and forgot password content initially
  signupContent.style.display = 'none';
  forgotPasswordContent.style.display = 'none';

  // Add event listener to the signup link
  signupLink.addEventListener('click', function(event) {
    event.preventDefault();
    // Hide login and forgot password forms, show signup form
    loginContent.style.display = 'none';
    forgotPasswordContent.style.display = 'none';
    signupContent.style.display = 'block';
  });

  // Add event listener to the login link
  loginLink.addEventListener('click', function(event) {
    event.preventDefault();
    // Hide signup and forgot password forms, show login form
    signupContent.style.display = 'none';
    forgotPasswordContent.style.display = 'none';
    loginContent.style.display = 'block';
  });

  // Add event listener to the forgot password link
  forgotPasswordLink.addEventListener('click', function(event) {
    event.preventDefault();
    // Hide login and signup forms, show forgot password form
    loginContent.style.display = 'none';
    signupContent.style.display = 'none';
    forgotPasswordContent.style.display = 'block';
  });
});
