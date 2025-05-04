import React, { useState, useCallback } from "react";
import {
  validateFIO,
  validateTel,
  validateMail,
  validateTable,
} from "../utils/validation";
import { validateDate, validateTime } from "../utils/dateTimeValidation";
import { TableSelect } from "./TableSelect";
import { Checkbox, FormControlLabel } from "@mui/material";

const OrderForm = () => {
  const [formData, setFormData] = useState({
    fio: "",
    tel: "",
    mail: "",
    date: "",
    time: "",
    table: "",
  });

  const [errors, setErrors] = useState({
    fio: "",
    tel: "",
    mail: "",
    date: "",
    time: "",
    table: "",
  });

  const handleInputChange = useCallback((name, value) => {
    setFormData((prevFormData) => ({
      ...prevFormData,
      [name]: value.trimStart(),
    }));
  }, []);

  const handleChange = (e) => {
    const { name, value } = e.target;

    let processedValue = value;

    if (name === "fio") {
      processedValue = value.replace(/[^a-zA-Zа-яА-Я\s-]/g, "");
    } else if (name === "tel") {
      processedValue = value.replace(/[^0-9+]/g, "");
    } else if (name === "mail") {
      processedValue = value.replace(/\s/g, "");
    }

    handleInputChange(name, processedValue);

    const timerId = setTimeout(() => {
      validateField(name, processedValue);
    }, 300);

    return () => clearTimeout(timerId);
  };

  const validateField = (name, value) => {
    let error = "";

    switch (name) {
      case "fio":
        error = validateFIO(value);
        break;
      case "tel":
        error = validateTel(value);
        break;
      case "mail":
        error = validateMail(value);
        break;
      case "date":
        error = validateDate(value, 2);
        break;
      case "time":
        error = validateTime(value);
        break;
      case "table":
        error = validateTable(value);
        break;
      default:
        break;
    }

    setErrors((prevErrors) => ({
      ...prevErrors,
      [name]: error,
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    Object.keys(formData).forEach((name) => {
      validateField(name, formData[name]);
    });

    const isValid = Object.values(errors).every((error) => error === "");

    if (isValid) {
      alert("Форма отправлена!");
    } else {
      alert("Пожалуйста, исправьте ошибки в форме.");
    }
  };

  const handleTableSelect = (tableNumber) => {
    setFormData({ ...formData, table: tableNumber });
    validateField("table", tableNumber);
  };

  return (
    <section>
      <div className="content content-center" id="book">
        <h2>Забронировать столик</h2>
        <form onSubmit={handleSubmit}>
          <div className="left-side">
            <div className="input-block">
              <label htmlFor="fio">
                <h6>ФИО:</h6>
              </label>
              <input
                type="text"
                name="fio"
                value={formData.fio}
                onChange={handleChange}
                maxLength="100"
                required
              />
              {errors.fio && <p className="error-message">{errors.fio}</p>}
            </div>
            <div className="input-block">
              <label htmlFor="tel">
                <h6>Телефон:</h6>
              </label>
              <input
                type="text"
                name="tel"
                value={formData.tel}
                onChange={handleChange}
                maxLength="15"
                required
              />
              {errors.tel && <p className="error-message">{errors.tel}</p>}
            </div>
            <div className="input-block">
              <label htmlFor="mail">
                <h6>Электронная почта:</h6>
              </label>
              <input
                type="email"
                name="mail"
                value={formData.mail}
                onChange={handleChange}
                maxLength="100"
                required
              />
              {errors.mail && <p className="error-message">{errors.mail}</p>}
            </div>
            <div className="input-block">
              <FormControlLabel
                label="Получать уведомления"
                control={<Checkbox />}
              />
            </div>
          </div>
          <div className="right-side">
            <div className="input-block">
              <label htmlFor="date">
                <h6>Дата:</h6>
              </label>
              <input
                type="date"
                name="date"
                value={formData.date}
                onChange={handleChange}
                required
              />
              {errors.date && <p className="error-message">{errors.date}</p>}
            </div>
            <div className="input-block">
              <label htmlFor="time">
                <h6>Время:</h6>
              </label>
              <input
                type="time"
                name="time"
                value={formData.time}
                onChange={handleChange}
                required
              />
              {errors.time && <p className="error-message">{errors.time}</p>}
            </div>
            <div className="input-block">
              <label htmlFor="table">
                <h6>Столик:</h6>
              </label>
              <TableSelect
                selectedTable={formData.table}
                onSelect={handleTableSelect}
                error={errors.table}
              />
            </div>
          </div>
          <div className="submit-button">
            <input
              type="submit"
              value="Забронировать"
              className="button filled"
            />
          </div>
        </form>
      </div>
    </section>
  );
};

export default OrderForm;
