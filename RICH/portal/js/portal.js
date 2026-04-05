async function checkUser() {
  const { data } = await supabaseClient.auth.getSession();

  if (!data.session) {
    window.location.href = "../login-test.html";
    return null;
  }

  return data.session.user;
}

function setUserUI(user) {
  const emailEl = document.getElementById("user-email");
  const avatarEl = document.getElementById("user-avatar");

  if (!user) return;

  emailEl.textContent = user.email;

  const firstLetter = user.email ? user.email.charAt(0).toUpperCase() : "R";
  avatarEl.textContent = firstLetter;
}

async function logoutUser() {
  await supabaseClient.auth.signOut();
  window.location.href = "../login-test.html";
}

function setupAnimations() {
  const fadeEls = document.querySelectorAll(".fade-up");

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("show");
      }
    });
  }, {
    threshold: 0.15
  });

  fadeEls.forEach((el) => observer.observe(el));
}

async function initPortal() {
  const user = await checkUser();
  if (!user) return;

  setUserUI(user);

  const logoutBtn = document.getElementById("logout-btn");
  logoutBtn.addEventListener("click", logoutUser);

  setupAnimations();
}

initPortal();