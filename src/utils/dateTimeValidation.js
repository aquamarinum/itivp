// utils/dateTimeValidation.js
export const validateDate = (date, monthsAhead) => {
  if (!date) {
    return "Дата обязательна для заполнения.";
  }

  const selectedDate = new Date(date);
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const maxDate = new Date();
  maxDate.setMonth(today.getMonth() + monthsAhead);
  maxDate.setDate(today.getDate());
  maxDate.setHours(0, 0, 0, 0);

  if (selectedDate < today) {
    return "Дата не может быть в прошлом или сегодня.";
  }

  if (selectedDate > maxDate) {
    return `Дата не может быть больше, чем на ${monthsAhead} месяцев вперед.`;
  }

  return "";
};

export const validateTime = (time) => {
  if (!time) {
    return "Время обязательно для заполнения.";
  }

  const [hours, minutes] = time.split(":").map(Number);

  if (hours >= 23 || hours < 10) {
    return "Время должно быть между 10:00 и 23:00.";
  }

  return "";
};
