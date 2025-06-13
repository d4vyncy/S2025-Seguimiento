import { Routes } from "@angular/router";
import { HomeComponent } from "./pages/home-component/home-component";
import { AboutComponent } from "./pages/about-component/about-component";
import { NoAutorizadoComponent } from "./no-autorizado/no-autorizado";
import { SharedLayoutComponent } from "../layouts/shared-layout-component/shared-layout-component";


export const sharedRoutes: Routes = [
  {
    path: '',
    component: SharedLayoutComponent,
    children: [
      {
        path: '',
        component: HomeComponent,
      },
      {
        path: 'acercade',
        component: AboutComponent,
      },
      {
        path: 'noAutorizado',
        component: NoAutorizadoComponent,
      },
    ],
  },
  {
    path: '**',
    redirectTo: '',
  },
];

export default sharedRoutes;
