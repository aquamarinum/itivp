import React from "react";
import { Link } from "react-router-dom";

const IntroSection = () => {
  return (
    <section className="intro">
      <div className="content content-between">
        <div className="content-left">
          <h1>Самая вкусная пицца во вселенной</h1>
          <p className="subtitle">
            Мы создаем пиццу, которая удивляет и радует, используя только самые
            свежие и качественные ингредиенты.
          </p>
          <div className="intro-buttons">
            <Link to="/menu" className="button filled">
              <p>В меню</p>
            </Link>
            <a href="#book" className="button filled">
              <p>Забронировать</p>
            </a>
          </div>
        </div>
      </div>
    </section>
  );
};

export default IntroSection;
