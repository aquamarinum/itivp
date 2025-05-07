import React from "react";

const ContactsSection = () => {
  return (
    <section>
      <div className="content content-between">
        <div className="content-left">
          <h2>Контакты</h2>
          <ul className="contacts">
            <li>
              <h6>Сайт:</h6>
              <a href="./index.html">www.nextpizza.com</a>
            </li>
            <li>
              <h6>Email:</h6>
              <a href="mailto:examplemail@gmail.com">examplemail@gmail.com</a>
            </li>
            <li>
              <h6>Телефон:</h6>
              <a href="tel:+375291234567">+375291234567</a>
              <br />
              <a href="tel:+375339876543">+375339876543</a>
            </li>
            <li>
              <h6>Telegram:</h6>
              <a href="https://t.me/exmpl">@nextpizza</a>
            </li>
          </ul>
        </div>
        <div className="content-right">
          <div className="map-container">
            <a
              href="https://yandex.by/maps/org/outleto/1243149652/?utm_medium=mapframe&utm_source=maps"
              style={{
                color: "#eee",
                fontSize: "12px",
                position: "absolute",
                top: 0,
              }}
            >
              Outleto
            </a>
            <a
              href="https://yandex.by/maps/157/minsk/category/shopping_mall/184108083/?utm_medium=mapframe&utm_source=maps"
              style={{
                color: "#eee",
                fontSize: "12px",
                position: "absolute",
                top: "14px",
              }}
            >
              Торговый центр в Минске
            </a>
            <iframe
              src="https://yandex.by/map-widget/v1/?ll=27.551496%2C53.886490&mode=poi&poi%5Bpoint%5D=27.517760%2C53.876802&poi%5Buri%5D=ymapsbm1%3A%2F%2Forg%3Foid%3D1243149652&z=12.93"
              frameBorder="1"
              allowFullScreen={true}
              style={{ position: "relative" }}
            ></iframe>
          </div>
        </div>
      </div>
    </section>
  );
};

export default ContactsSection;
