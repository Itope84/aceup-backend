import Vue from 'vue'
import Router from 'vue-router'

// Containers
import DefaultContainer from "../containers/DefaultContainer"

// Views
import Dashboard from "../views/Dashboard"

import Courses from "../pages/courses/Index"
import CreateCourse from "../pages/courses/Create"
import EditCourse from "../pages/courses/Edit"

import Topics from "../pages/topics/Index"
import CreateTopic from "../pages/topics/Create"
import EditTopic from "../pages/topics/Edit"
import TopicSlides from "../pages/topics/Slides"

import EditSlide from "../pages/slides/Edit"
import CreateSlide from "../pages/slides/Create"

import Colors from "../views/theme/Colors"
import Typography from "../views/theme/Typography"

import Charts from "../views/Charts"
import Widgets from "../views/Widgets"

// Views - Components
import Cards from "../views/base/Cards"
import Forms from "../views/base/Forms"
import Switches from "../views/base/Switches"
import Tables from "../views/base/Tables"
import Tabs from "../views/base/Tabs"
import Breadcrumbs from "../views/base/Breadcrumbs"
import Carousels from "../views/base/Carousels"
import Collapses from "../views/base/Collapses"
import Jumbotrons from "../views/base/Jumbotrons"
import ListGroups from "../views/base/ListGroups"
import Navs from "../views/base/Navs"
import Navbars from "../views/base/Navbars"
import Paginations from "../views/base/Paginations"
import Popovers from "../views/base/Popovers"
import ProgressBars from "../views/base/ProgressBars"
import Tooltips from "../views/base/Tooltips"

// Views - Buttons
import StandardButtons from "../views/buttons/StandardButtons"
import ButtonGroups from "../views/buttons/ButtonGroups"
import Dropdowns from "../views/buttons/Dropdowns"
import BrandButtons from "../views/buttons/BrandButtons"

// Views - Icons
import Flags from "../views/icons/Flags"
import FontAwesome from "../views/icons/FontAwesome"
import SimpleLineIcons from "../views/icons/SimpleLineIcons"
import CoreUIIcons from "../views/icons/CoreUIIcons"

// Views - Notifications
import Alerts from "../views/notifications/Alerts"
import Badges from "../views/notifications/Badges"
import Modals from "../views/notifications/Modals"

// Views - Pages
import Page404 from "../views/pages/Page404"
import Page500 from "../views/pages/Page500"
import Login from "../views/pages/Login"
import Register from "../views/pages/Register"

// Users
import Users from "../views/users/Users"
import User from "../views/users/User"

Vue.use(Router)

export default new Router({
  mode: 'hash', // https://router.vuejs.org/api/#mode
  linkActiveClass: 'open active',
  scrollBehavior: () => ({ y: 0 }),
  routes: [
    {
      path: '/',
      redirect: '/dashboard',
      name: 'Home',
      component: DefaultContainer,
      children: [
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard
        },
        {
          path: 'courses',
          redirect: '/courses/',
          name: 'courses',
          component: {
            render(c) {return c('router-view')}
          },
          children: [
            {
              path: '/',
              name: 'All Courses',
              component: Courses
            },
            {
              path: 'create',
              name: 'create',
              component: CreateCourse
            },
            {
              path: ':id/edit',
              name: 'edit',
              component: EditCourse
            }
          ]
        },

        {
          path: 'topics',
          redirect: '/topics/',
          name: 'topics',
          component: {
            render(c) {return c('router-view')}
          },
          children: [
            {
              path: '/',
              name: 'All Topics',
              component: Topics
            },
            {
              path: 'create',
              name: 'New Topic',
              component: CreateTopic
            },
            {
              path: ':id/edit',
              name: 'Edit Topic',
              component: EditTopic
            },
            {
              path: ':topicId/slides',
              name: 'Topic Slides',
              component: TopicSlides
            },
            {
              path: ':topicId/slides/create',
              name: 'New Slide',
              component: CreateSlide
            },
          ]
        },

        {
          path: 'slides',
          redirect: '/topics/',
          name: 'Slides',
          component: {
            render(c) {return c('router-view')}
          },
          children: [
            // {
            //   path: '/',
            //   name: 'All Topics',
            //   component: Topics
            // },
            
            {
              path: ':id/edit',
              name: 'Edit Slide',
              component: EditSlide
            },
            // {
            //   path: ':id/edit',
            //   name: 'Edit Slide',
            //   component: EditSlide
            // }
          ]
        },


        {
          path: 'theme',
          redirect: '/theme/colors',
          name: 'Theme',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'colors',
              name: 'Colors',
              component: Colors
            },
            {
              path: 'typography',
              name: 'Typography',
              component: Typography
            }
          ]
        },
        {
          path: 'charts',
          name: 'Charts',
          component: Charts
        },
        {
          path: 'widgets',
          name: 'Widgets',
          component: Widgets
        },
        {
          path: 'users',
          meta: { label: 'Users'},
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: '',
              component: Users,
            },
            {
              path: ':id',
              meta: { label: 'User Details'},
              name: 'User',
              component: User,
            },
          ]
        },
        {
          path: 'base',
          redirect: '/base/cards',
          name: 'Base',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'cards',
              name: 'Cards',
              component: Cards
            },
            {
              path: 'forms',
              name: 'Forms',
              component: Forms
            },
            {
              path: 'switches',
              name: 'Switches',
              component: Switches
            },
            {
              path: 'tables',
              name: 'Tables',
              component: Tables
            },
            {
              path: 'tabs',
              name: 'Tabs',
              component: Tabs
            },
            {
              path: 'breadcrumbs',
              name: 'Breadcrumbs',
              component: Breadcrumbs
            },
            {
              path: 'carousels',
              name: 'Carousels',
              component: Carousels
            },
            {
              path: 'collapses',
              name: 'Collapses',
              component: Collapses
            },
            {
              path: 'jumbotrons',
              name: 'Jumbotrons',
              component: Jumbotrons
            },
            {
              path: 'list-groups',
              name: 'List Groups',
              component: ListGroups
            },
            {
              path: 'navs',
              name: 'Navs',
              component: Navs
            },
            {
              path: 'navbars',
              name: 'Navbars',
              component: Navbars
            },
            {
              path: 'paginations',
              name: 'Paginations',
              component: Paginations
            },
            {
              path: 'popovers',
              name: 'Popovers',
              component: Popovers
            },
            {
              path: 'progress-bars',
              name: 'Progress Bars',
              component: ProgressBars
            },
            {
              path: 'tooltips',
              name: 'Tooltips',
              component: Tooltips
            }
          ]
        },
        {
          path: 'buttons',
          redirect: '/buttons/standard-buttons',
          name: 'Buttons',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'standard-buttons',
              name: 'Standard Buttons',
              component: StandardButtons
            },
            {
              path: 'button-groups',
              name: 'Button Groups',
              component: ButtonGroups
            },
            {
              path: 'dropdowns',
              name: 'Dropdowns',
              component: Dropdowns
            },
            {
              path: 'brand-buttons',
              name: 'Brand Buttons',
              component: BrandButtons
            }
          ]
        },
        {
          path: 'icons',
          redirect: '/icons/font-awesome',
          name: 'Icons',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'coreui-icons',
              name: 'CoreUI Icons',
              component: CoreUIIcons
            },
            {
              path: 'flags',
              name: 'Flags',
              component: Flags
            },
            {
              path: 'font-awesome',
              name: 'Font Awesome',
              component: FontAwesome
            },
            {
              path: 'simple-line-icons',
              name: 'Simple Line Icons',
              component: SimpleLineIcons
            }
          ]
        },
        {
          path: 'notifications',
          redirect: '/notifications/alerts',
          name: 'Notifications',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'alerts',
              name: 'Alerts',
              component: Alerts
            },
            {
              path: 'badges',
              name: 'Badges',
              component: Badges
            },
            {
              path: 'modals',
              name: 'Modals',
              component: Modals
            }
          ]
        }
      ]
    },
    {
      path: '/pages',
      redirect: '/pages/404',
      name: 'Pages',
      component: {
        render (c) { return c('router-view') }
      },
      children: [
        {
          path: '404',
          name: 'Page404',
          component: Page404
        },
        {
          path: '500',
          name: 'Page500',
          component: Page500
        },
        {
          path: 'login',
          name: 'Login',
          component: Login
        },
        {
          path: 'register',
          name: 'Register',
          component: Register
        }
      ]
    }
  ]
})
