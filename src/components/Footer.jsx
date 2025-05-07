import React from "react";

import socials_1 from "../assets/img/pizza-logo.png";

const Footer = () => {
  return (
    <footer>
      <div className="content content-center">
        <h2>Next Pizza</h2>
        <p>
          Присоединяйтесь к семье Next Pizza и откройте для себя вкус будущего!
          ООО "Некст Пицца". Все права защищены ©
        </p>
        <ul className="socials">
          <li>
            <a href="https://vk.com">
              <img src={socials_1} alt="social-icon" />
            </a>
          </li>
          <li>
            <a href="https://vk.com">
              <img src={socials_1} alt="social-icon" />
            </a>
          </li>
          <li>
            <a href="https://vk.com">
              <img src={socials_1} alt="social-icon" />
            </a>
          </li>
          <li>
            <a href="https://vk.com">
              <img src={socials_1} alt="social-icon" />
            </a>
          </li>
          <li>
            <a href="https://vk.com">
              <img src={socials_1} alt="social-icon" />
            </a>
          </li>
        </ul>
      </div>
    </footer>
  );
};

export default Footer;
