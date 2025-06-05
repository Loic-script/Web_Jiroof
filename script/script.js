document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const navMenu = document.querySelector("nav");

    menuToggle.addEventListener("click", () => {
        navMenu.classList.toggle("hidden");
        navMenu.classList.toggle("flex");
      });
});

document.addEventListener("DOMContentLoaded", function () {
    const newsletterInput = document.querySelector(".newsletter-input");
    const subscribeButton = newsletterInput.nextElementSibling;

    newsletterInput.addEventListener("focus", function () {
        this.classList.add("border-primary");
    });

    newsletterInput.addEventListener("blur", function () {
        if (this.value === "") {
            this.classList.remove("border-primary");
        }
    });

    subscribeButton.addEventListener("click", function () {
        const email = newsletterInput.value;
        if (email && /^\S+@\S+\.\S+$/.test(email)) {
            alert("Merci de vous être inscrit à notre newsletter !");
            newsletterInput.value = "";
        } else {
            alert("Veuillez entrer une adresse email valide.");
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const menuButton = document.querySelector(".ri-menu-line").parentElement;
    const nav = document.querySelector("nav");

    menuButton.addEventListener("click", function () {
        if (nav.classList.contains("hidden")) {
            nav.classList.remove("hidden");
            nav.classList.add(
                "flex",
                "flex-col",
                "absolute",
                "top-16",
                "right-4",
                "bg-black",
                "border",
                "border-gray-800",
                "p-4",
                "rounded",
                "shadow-lg",
                "z-50",
                "space-y-4",
            );
        } else {
            nav.classList.add("hidden");
            nav.classList.remove(
                "flex",
                "flex-col",
                "absolute",
                "top-16",
                "right-4",
                "bg-black",
                "border",
                "border-gray-800",
                "p-4",
                "rounded",
                "shadow-lg",
                "z-50",
                "space-y-4",
            );
        }
    });
});

//   other page 
function openPopup() {
    document.getElementById("popup").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}