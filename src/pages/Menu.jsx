import React, { useContext, useState } from "react";
import { pizzas } from "../data";
import Product from "../components/Product";
import { NotificationContext } from "../components/NotificationProvider";

const categories = [
  { id: 0, title: "все" },
  { id: 1, title: "мясные" },
  { id: 2, title: "вегетарианские" },
  { id: 3, title: "гриль" },
  { id: 4, title: "острые" },
  { id: 5, title: "закрытые" },
];

const Menu = () => {
  const [activeCategory, setActiveCategory] = useState(categories[0].id);
  const [products, setProducts] = useState(pizzas);
  const { isFlagChecked } = useContext(NotificationContext);

  const onCategoryChange = (newCat = 0) => {
    if (isFlagChecked) {
      alert("Выбрана категория: " + categories[newCat].title);
    }
    console.log(newCat);
    setActiveCategory(newCat);
    if (newCat > 0) {
      setProducts(pizzas.filter((el) => el.category === newCat));
    } else {
      setProducts(pizzas);
    }
  };

  return (
    <main className="wrapper">
      <section>
        <div className="catalog-container">
          <h2>Меню</h2>
          <ul className="menu-nav">
            {categories.map((el) => (
              <li
                key={el.id}
                onClick={() => onCategoryChange(el.id)}
                className={activeCategory === el.id ? "active" : ""}
              >
                <p>{el.title}</p>
              </li>
            ))}
          </ul>
          <div className="catalog">
            {products.map((pizza) => (
              <Product pizza={pizza} key={pizza.id} />
            ))}
          </div>
          {/* <ul className="menu-pag">
            <li>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
              </svg>
            </li>
            <li className="active">
              <p>1</p>
            </li>
            <li>
              <p>2</p>
            </li>
            <li>
              <p>3</p>
            </li>
            <li>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" />
              </svg>
            </li>
          </ul> */}
        </div>
      </section>
    </main>
  );
};

export default Menu;
