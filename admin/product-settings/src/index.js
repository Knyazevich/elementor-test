import { createRoot, Suspense } from '@wordpress/element';
import { createHashRouter, RouterProvider } from 'react-router-dom';
import { Spinner } from '@wordpress/components';
import DashboardController from './controller/Dashboard/DashboardController';
import AddProductController from './controller/AddProduct/AddProductController';
import EditProductController from './controller/EditProduct/EditProductController';

// Define global variable's default values to prevent errors
window.setGlobalAlert = () => {
};

const wrapComponent = (component) => (
  <Suspense fallback={<Spinner />}>{component}</Suspense>
);

const router = createHashRouter([
  {
    path: '/',
    children: [
      {
        path: '',
        element: wrapComponent(<DashboardController />),
      },
      {
        path: 'add',
        element: wrapComponent(<AddProductController />),
      },
      {
        path: 'edit',
        element: wrapComponent(<EditProductController />),
      },
    ],
  },
]);

window.addEventListener('DOMContentLoaded', () => {
  const root = createRoot(
    document.querySelector('#twenty-twenty-child-product-settings'),
  );
  root.render(
    <RouterProvider
      router={router}
      fallbackElement={<Spinner />}
    />,
  );
});
