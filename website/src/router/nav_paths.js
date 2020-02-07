export default [
  // {
  //   group: '/admin',
  //   icon: 'mdi-clipboard-outline',
  //   title: 'nav.admin',
  //   children: [
  //     {
  //       icon: 'mdi-account-star',
  //       title: 'nav.organization',
  //       to: 'organization',
  //     },
  //   ],
  // },
  {
    icon: 'mdi-view-dashboard',
    title: 'nav.dashboard',
    to: '/',
  },
  {
    icon: 'mdi-account-group',
    title: 'nav.users',
    to: '/users',
  },
  {
    icon: 'mdi-cart',
    title: 'nav.trades',
    to: '/trades',
  },
  {
    group: '/log',
    icon: 'mdi-clipboard-outline',
    title: 'nav.logs',
    children: [
      {
        icon: 'mdi-cart-minus',
        title: 'nav.sell',
        to: 'sell',
      },
      {
        icon: 'mdi-cart-plus',
        title: 'nav.buy',
        to: 'buy',
      },
      {
        icon: 'mdi-anvil',
        title: 'nav.craft',
        to: 'craft',
      },
      {
        icon: 'mdi-tractor',
        title: 'nav.harvest',
        to: 'harvest',
      },
      {
        icon: 'mdi-shovel',
        title: 'nav.pickup',
        to: 'pickup',
      },
      {
        icon: 'mdi-shovel-off',
        title: 'nav.place',
        to: 'place',
      },
      {
        icon: 'mdi-account-clock',
        title: 'nav.play',
        to: 'play',
      },
    ],
  },

]
