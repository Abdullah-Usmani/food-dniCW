// Function to show the landing page and hide the login/sign-up page
function showLandingPage() {
    document.getElementById("login-signup-page").style.display = "none";
    document.getElementById("landing-page").style.display = "block";
  }
  
  // Function to simulate successful login (replace this with your actual login mechanism)
  function simulateSuccessfulLogin() {
    // Simulating successful login with a timeout (replace this with your actual login logic)
    setTimeout(function() {
      showLandingPage(); // Show the landing page after successful login
    }, 1000); // Simulating 1 second delay, replace this with your actual login process
  }
  
  // Call simulateSuccessfulLogin when the page loads (for demonstration purposes)
  window.onload = function() {
    simulateSuccessfulLogin(); // Call the login simulation function
  };
  