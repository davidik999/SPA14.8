document.addEventListener('DOMContentLoaded', function () {
    const logoImages = ["images/1.jpg", "images/2.jpg", "images/3.jpg"];
    let currentLogoIndex = 0;

    const logoImage = document.getElementById('logoImage');

    function changeLogo() {
        logoImage.style.opacity = 0;

        setTimeout(() => {
            logoImage.src = logoImages[currentLogoIndex];
            logoImage.style.opacity = 1;
        }, 1000);

        currentLogoIndex = (currentLogoIndex + 1) % logoImages.length;
    }

    setInterval(changeLogo, 3000);
});


