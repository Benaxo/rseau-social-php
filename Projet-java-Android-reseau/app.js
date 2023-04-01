document.addEventListener("DOMContentLoaded", () => {
  const sign_in_btn = document.querySelector("#sign-in-btn");
  const sign_up_btn = document.querySelector("#sign-up-btn");
  const container = document.querySelector(".container");

  // Vérifier si l'animation a déjà été jouée
  const animationState = localStorage.getItem("animation-state");
  if (animationState === "sign-up-mode") {
    container.classList.add("sign-up-mode");
  }

  sign_up_btn.addEventListener("click", () => {
    container.classList.add("sign-up-mode");

    // Enregistrer l'état de l'animation dans localStorage
    localStorage.setItem("animation-state", "sign-up-mode");
  });

  sign_in_btn.addEventListener("click", () => {
    container.classList.remove("sign-up-mode");

    // Supprimer l'état de l'animation dans localStorage
    localStorage.removeItem("animation-state");
  });
});