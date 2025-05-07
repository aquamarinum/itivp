// utils/validation.js
export const validateFIO = (fio) => {
  if (!fio.trim()) {
    return "ФИО обязательно для заполнения.";
  } else if (fio.length < 3) {
    return "ФИО должно содержать не менее 3 символов.";
  } else if (fio.length > 100) {
    return "ФИО должно содержать не более 100 символов.";
  } else if (!/^[a-zA-Zа-яА-Я\s-]+$/.test(fio)) {
    return "ФИО должно содержать только буквы, пробелы и дефисы.";
  }
  return "";
};

export const validateTel = (tel) => {
  if (!tel.trim()) {
    return "Телефон обязателен для заполнения.";
  } else if (!/^\+?[0-9]{10,15}$/.test(tel)) {
    return "Неверный формат телефона. Должно быть от 10 до 15 цифр, возможно с '+'.";
  }
  return "";
};

export const validateMail = (mail) => {
  const trimmedMail = mail.trim();
  if (!trimmedMail) {
    return "Электронная почта обязательна для заполнения.";
  } else if (
    !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(trimmedMail)
  ) {
    return "Неверный формат электронной почты.";
  }
  return "";
};

export const validateTable = (table) => {
  if (!table) {
    return "Номер столика обязателен для заполнения.";
  } else if (isNaN(table)) {
    return "Номер столика должен быть числом.";
  } else {
    const tableNumber = parseInt(table, 10);
    if (tableNumber < 1 || tableNumber > 50) {
      return "Номер столика должен быть от 1 до 50.";
    }
  }
  return "";
};
