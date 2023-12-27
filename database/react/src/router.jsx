import {
    Navigate,
  createBrowserRouter
} from "react-router-dom";
import Login from "./views/Login";
import Signup from "./views/Signup";
import Users from "./views/User";
import NotFound from "./views/NotFound";
import DefaultLayout from "./views/components/DefaultLayout";
import Guestlayout from "./views/components/GuestLayout";
import Dashboard from "./views/Dasboards";
import AdvertisementsForm from "./views/AdvertisementsForm";


const router = createBrowserRouter([
    {
        path:'/',
        element:<DefaultLayout/>,
        children:[
            {
                path:'/',
                element:<Navigate to="/advertisements"/>
            },
            {
                path: '/dashboard',
                element: <Dashboard/>
            },
            {
                path: '/advertisements',
                element: <Users/>
            },
            {
                path: '/advertisements/store',
                element: <AdvertisementsForm/>
            },
        ]
    },
    {
        path:'/',
        element:<Guestlayout/>,
        children:[
            {
                path: '/login',
                element: <Login/>
            },
            {
                path: '/register',
                element: <Signup/>
            }
        ]
    },
    
    {
        path: '*',
        element: <NotFound/>
    },
]);

export default router;