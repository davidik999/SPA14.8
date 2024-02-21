document.addEventListener('DOMContentLoaded', function () {
    const dynamicTexts = ["Погода", "Новости", "Туризм", "Спорт"];
    let currentIndex = 0;

    // Функция обновления динамического поля
    function updateDynamicField() {
        dynamicField.textContent = dynamicTexts[currentIndex];
        currentIndex = (currentIndex + 1) % dynamicTexts.length;
    }

    // Вызываем функцию при загрузке страницы
    updateDynamicField();

    // Обновляем поле каждые 3 секунды
    setInterval(updateDynamicField, 3000);

    // Создаем 5 изображений и добавляем их в контейнер
    const imagesContainer = document.getElementById('imagesContainer');
    const imageCaptions = ["Погода", "Туризм", "Новости", "Госуслуги", "Справка"];

    for (let i = 1; i <= 5; i++) {
        const imgContainer = document.createElement('div');
        imgContainer.classList.add('image-container');

        // Создаём ссылку для каждого изображения
        const link = document.createElement('a');
        link.href = `page${i}.html`; // Установим нужную страницу для каждого изображения

        const img = document.createElement('img');
        img.src = `images/image${i}.jpg`; // Путь к изображению
        img.alt = `Image ${i}`;
        img.width = 75;
        img.height = 75;

        const caption = document.createElement('div');
        caption.classList.add('image-caption');
        caption.textContent = imageCaptions[i - 1];

        // Добавим изображение и надпись к ссылке
        link.appendChild(img);
        link.appendChild(caption);

        // Добавим ссылку в контейнер imagesContainer
        imgContainer.appendChild(link);
        imagesContainer.appendChild(imgContainer);
    }
});
