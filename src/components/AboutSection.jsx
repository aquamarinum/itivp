import React from "react";

import pizza_pic_1 from "../assets/img/pizza1.png";
import pizza_pic_2 from "../assets/img/pizza2.png";

const AboutSection = () => {
  return (
    <section className="about">
      <div className="content content-between">
        <div className="content-left">
          <h2 className="left">О нас</h2>
          <p>
            Next Pizza – это не просто пиццерия, это место, где традиции
            встречаются с инновациями. Здесь вы всегда найдете что-то новое и
            интересное, а наша уютная атмосфера и дружелюбный персонал сделают
            ваш визит незабываемым.
          </p>
          <p>
            Мы стремимся к тому, чтобы каждый кусочек нашей пиццы приносил вам
            радость и удовольствие. Присоединяйтесь к семье Next Pizza и
            откройте для себя вкус будущего!
          </p>
        </div>
        <div className="content-right">
          <div className="about-illustrations">
            <div className="box">
              <img src={pizza_pic_1} alt="pizza-pic" />
            </div>
            <div className="box">
              <img src={pizza_pic_2} alt="pizza-pic" />
            </div>
            <div className="box">
              <img src={pizza_pic_2} alt="pizza-pic" />
            </div>
            <div className="box">
              <img src={pizza_pic_1} alt="pizza-pic" />
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default AboutSection;
