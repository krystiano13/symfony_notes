const title = document.querySelector('.HomeTitle');
const subtitle = document.querySelector('.HomeSubtitle');
const button = document.querySelector('.HomeButton');

console.log('test');

setTimeout(() => {
    title.className = "HomeTitle visible";
    subtitle.className = "HomeSubtitle visible";
    button.className = "HomeButton visible";
}, 950);