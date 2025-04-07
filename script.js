document.addEventListener("DOMContentLoaded", function () {
    // SIDEBAR FUNCTIONALITY
    const links = document.querySelectorAll(".sidebar ul li a");
    const currentPath = window.location.pathname.split("/").pop();

    links.forEach(link => {
        const linkPath = link.getAttribute("href").split("/").pop();
        if (linkPath === currentPath) {
            link.classList.add("active");
        }

        link.addEventListener("click", function () {
            links.forEach(l => l.classList.remove("active"));
            this.classList.add("active");
            localStorage.setItem("activeNavHref", this.getAttribute("href"));
        });

        link.addEventListener("mouseenter", function () {
            if (!this.classList.contains("active")) {
                this.style.backgroundColor = "#6e4634";
            }
        });

        link.addEventListener("mouseleave", function () {
            if (!this.classList.contains("active")) {
                this.style.backgroundColor = "transparent";
            }
        });
    });

    // CARD HOVER EFFECTS
    const cards = document.querySelectorAll(".card");
    cards.forEach(card => {
        card.style.cursor = "pointer";
        card.addEventListener("mouseenter", () => {
            card.style.boxShadow = "0 4px 12px rgba(0,0,0,0.2)";
        });
        card.addEventListener("mouseleave", () => {
            card.style.boxShadow = "2px 2px 5px rgba(0,0,0,0.1)";
        });
    });
});

// MODAL FUNCTIONALITY
function showDetails(type) {
    const modal = document.getElementById("infoModal");
    const message = document.getElementById("modalMessage");
    const actionBtn = document.getElementById("modalActionLink");

    if (type === "heritage") {
        message.innerHTML = "You have <b>218</b> heritage sites.";
        actionBtn.textContent = "View details";
        actionBtn.href = "heritage-sites.php";
    } else if (type === "engagement") {
        message.innerHTML = "There are <b>526</b> user engagements.";
        actionBtn.textContent = "View analytics";
        actionBtn.href = "#"; //to be updated
    } else if (type === "published") {
        message.innerHTML = "<b>17</b> sites have been recently published.";
        actionBtn.textContent = "View sites";
        actionBtn.href = "#"; //to be updated
    }
    modal.style.display = "flex";
}

function closeModal() {
    document.getElementById("infoModal").style.display = "none";
}
