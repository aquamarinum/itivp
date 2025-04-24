const totalItems = 100;
const batchSize = 20;
const itemList = document.getElementById("item-list");

for (let i = 0; i < totalItems; i++) {
  const div = document.createElement("div");
  div.className = "item";
  div.dataset.index = i;

  if (i < batchSize) {
    const img = new Image();
    img.src = `https://picsum.photos/seed/${i}/400/200`;
    div.appendChild(img);
  } else {
    div.innerHTML = `<span class="loading-text">Загрузка...</span>`;
  }

  itemList.appendChild(div);
}

function loadBatch(startIndex, count) {
  const items = Array.from(itemList.children).slice(startIndex, startIndex + count);
  items.forEach((item) => {
    const index = item.dataset.index;
    // Исключаем уже загруженные
    if (!item.querySelector("img")) {
      setTimeout(() => {
        const img = new Image();
        img.src = `https://picsum.photos/seed/${index}/400/200`;
        img.onload = () => {
          item.innerHTML = "";
          item.appendChild(img);
        };
      }, 500 + Math.random() * 500); 
    }
  });
}

let currentBatch = 1;

const observer = new IntersectionObserver((entries) => {
  const entry = entries[0];
  if (entry.isIntersecting) {
    const start = currentBatch * batchSize;
    if (start < totalItems) {
      loadBatch(start, batchSize);
      currentBatch++;
      const nextIndex = currentBatch * batchSize - 1;
      if (nextIndex < totalItems) {
        observer.observe(itemList.children[nextIndex]);
      }
    }
  }
}, {
  root: document.getElementById("container"),
  threshold: 0.5
});

observer.observe(itemList.children[batchSize - 1]);
