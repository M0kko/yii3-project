document.addEventListener('DOMContentLoaded', () => {
    const messageField = document.getElementById('message');
    const infoField = document.getElementById('message-info');

    if (!messageField || !infoField) {
        return;
    }

    const renderInfo = () => {
        const length = messageField.value.length;
        infoField.textContent = `Количество символов: ${length}`;
    };

    renderInfo();
    messageField.addEventListener('input', renderInfo);
});