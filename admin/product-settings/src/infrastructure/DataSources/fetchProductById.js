import apiFetch from '@wordpress/api-fetch';
import { THEME_PATH_NAMESPACE } from './index';

const fetchProductById = async (productId) => {
  try {
    const response = await apiFetch({
      path: `${THEME_PATH_NAMESPACE}/product/${productId}`,
      cache: 'no-store',
    });

    return response.data;
  } catch (e) {
    window.setGlobalAlert('negative', e.message);
  }
};

export default fetchProductById;
