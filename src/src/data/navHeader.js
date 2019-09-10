export default [
  {
    id: 1,
    parent_id: 0,
    name: 'Главная',
    link: 'index'
  },
  {
    id: 2,
    parent_id: 0,
    name: 'Каталог',
    link: '',
    children: [
      {
        id: 10,
        name: 'Кольца',
        link: 'category'
      },
      {
        id: 11,
        name: 'Серьги',
        link: 'category'
      },
      {
        id: 12,
        name: 'Кулоны',
        link: 'category'
      },
      {
        id: 13,
        name: 'Аксессуары',
        link: 'category'
      },
      {
        id: 14,
        name: 'Браслеты',
        link: 'category'
      }
    ]
  },
  {
    id: 3,
    parent_id: 0,
    name: 'Коллекция',
    link: 'category',
    children: [
      {
        id: 15,
        name: 'Зимняя коллекция',
        link: 'category'
      },
      {
        id: 16,
        name: 'Летняя коллекция',
        link: 'category'
      },
      {
        id: 17,
        name: 'Весенняя коллеция',
        link: 'category'
      },
      {
        id: 18,
        name: 'Осенняя коллекция',
        link: 'category'
      }
    ]
  },
  {
    id: 4,
    parent_id: 0,
    name: 'Лукбук',
    link: 'lookbook'
  },
  {
    id: 5,
    parent_id: 0,
    name: 'Изготовление на заказ',
    link: ''
  },
  {
    id: 6,
    parent_id: 0,
    name: 'Оплата и доставка',
    link: 'pay'
  },
  {
    id: 7,
    parent_id: 0,
    name: 'Статьи',
    link: 'paper'
  },
  {
    id: 8,
    parent_id: 0,
    name: 'О нас',
    link: 'about'
  },
  {
    id: 9,
    parent_id: 0,
    name: 'Контакты',
    link: 'contacts'
  }
]
