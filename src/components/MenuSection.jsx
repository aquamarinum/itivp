import React from "react";
import { Link } from "react-router-dom";
import Product from "./Product";

const MenuSection = ({ pizzas }) => {
  return (
    <section>
      <div className="content content-center">
        <h2>Меню</h2>
        <div className="preview">
          {pizzas.slice(0, 3).map((pizza, idx) => (
            <Product pizza={pizza} key={idx} />
          ))}
        </div>
        <Link to="/menu" className="button filled">
          <p>В меню</p>
        </Link>
      </div>
    </section>
  );
};

export default MenuSection;
