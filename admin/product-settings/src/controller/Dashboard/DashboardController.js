import { useEffect, useState } from '@wordpress/element';
import { createSearchParams, useNavigate } from 'react-router-dom';
import { produce } from 'immer';
import TABLE_HEADINGS from '../../domain/Dashboard/Dashboard';
import dashboardTableTransformer from '../../view/transformers/dashboardTableTransformer';
import DashboardView from '../../view/Dashboard/DashboardView';
import fetchProducts from '../../infrastructure/DataSources/fetchProducts';
import deleteProduct from '../../infrastructure/DataSources/deleteProduct';

function DashboardController() {
  const navigate = useNavigate();
  const [products, setProducts] = useState([]);
  const [isLoading, setIsLoading] = useState(true);

  const onAddNewButtonClick = () => {
    navigate({ pathname: 'add' });
  };

  const onEditButtonClick = (productId) => {
    navigate({
      pathname: 'edit',
      search: createSearchParams({ productId }).toString(),
    });
  };

  const onDeleteButtonClick = async (productId) => {
    const result = await deleteProduct(productId);

    if (result) {
      setProducts(
        produce((d) => {
          const productIndex = d.findIndex((product) => product.id === productId);

          if (productIndex !== -1) {
            d.splice(productIndex, 1);
          }
        }),
      );

      window.setGlobalAlert('positive', 'Product successfully deleted');
    } else {
      window.setGlobalAlert('negative', 'Product deletion error');
    }
  };

  useEffect(() => {
    const fetchData = async () => {
      // FIXME: A pagination is needed here
      const fetchedProducts = await fetchProducts();
      setProducts(produce(fetchedProducts, (d) => d));
      setIsLoading(false);
    };

    fetchData();
  }, []);

  return (
    <DashboardView
      onAddNewButtonClick={onAddNewButtonClick}
      tableHeadings={TABLE_HEADINGS}
      tableData={dashboardTableTransformer(products, onEditButtonClick, onDeleteButtonClick)}
      isLoading={isLoading}
    />
  );
}

export default DashboardController;
