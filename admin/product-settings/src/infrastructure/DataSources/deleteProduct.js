import apiFetch from '@wordpress/api-fetch';
import { THEME_PATH_NAMESPACE } from './index';

const deleteProduct = async (productId) => {
  const response = await apiFetch({
    path: `${THEME_PATH_NAMESPACE}/product/${productId}`,
    method: 'DELETE',
  });

  return response.success;
};

export default deleteProduct;
