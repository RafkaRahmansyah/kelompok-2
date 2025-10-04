document.addEventListener("DOMContentLoaded", function () {
  // Tab switching
  const tabBtns = document.querySelectorAll(".tab-btn");
  const authForms = document.querySelectorAll(".auth-form");

  tabBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const tabId = btn.getAttribute("data-tab");

      // Update active tab button
      tabBtns.forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");

      // Show corresponding form
      authForms.forEach((form) => {
        form.classList.remove("active");
        if (form.id === tabId) {
          form.classList.add("active");
        }
      });
    });
  });

  // Role selection handling
  const roleSelect = document.getElementById("register-role");
  const nipGroup = document.getElementById("nip-group");
  const nisGroup = document.getElementById("nis-group");

  if (roleSelect) {
    roleSelect.addEventListener("change", function () {
      if (this.value === "guru") {
        nipGroup.style.display = "block";
        nisGroup.style.display = "none";
        document.getElementById("register-nip").required = true;
        document.getElementById("register-nis").required = false;
      } else if (this.value === "siswa") {
        nipGroup.style.display = "none";
        nisGroup.style.display = "block";
        document.getElementById("register-nip").required = false;
        document.getElementById("register-nis").required = true;
      } else {
        nipGroup.style.display = "none";
        nisGroup.style.display = "none";
        document.getElementById("register-nip").required = false;
        document.getElementById("register-nis").required = false;
      }
    });
  }

  // Form submission
  const loginForm = document.querySelector("#login form");
  const registerForm = document.querySelector("#register form");

  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      e.preventDefault();
      submitForm(this, "login");
    });
  }

  if (registerForm) {
    registerForm.addEventListener("submit", function (e) {
      e.preventDefault();
      submitForm(this, "register");
    });
  }

  function submitForm(form, action) {
    const formData = new FormData(form);
    const url = `proses.php?action=${action}`;

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        showNotification(data.status, data.message);

        if (data.status === "success") {
          if (action === "login") {
            showRocketAnimation();
            setTimeout(() => {
              window.location.href = "pages/dashboard.php";
            }, 3000);
          } else {
            // Reset form and switch to login tab
            form.reset();
            document.querySelector('[data-tab="login"]').click();
          }
        }
      })
      .catch((error) => {
        showNotification("error", "Terjadi kesalahan: " + error.message);
      });
  }

  function showNotification(type, message) {
    const notification = document.getElementById("notification");
    notification.textContent = message;
    notification.className = `notification ${type}`;
    notification.classList.add("show");

    setTimeout(() => {
      notification.classList.remove("show");
    }, 5000);
  }

  function showRocketAnimation() {
    const rocketContainer = document.createElement("div");
    rocketContainer.className = "rocket-container";
    rocketContainer.innerHTML = '<div class="rocket"></div>';
    document.body.appendChild(rocketContainer);

    setTimeout(() => {
      rocketContainer.classList.add("show");
    }, 100);

    setTimeout(() => {
      document.body.removeChild(rocketContainer);
    }, 3500);
  }
});
