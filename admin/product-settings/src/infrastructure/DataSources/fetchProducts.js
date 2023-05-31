import apiFetch from '@wordpress/api-fetch';
import { THEME_PATH_NAMESPACE } from './index';

const fetchProducts = async () => {
  try {
    const response = await apiFetch({
      path: `${THEME_PATH_NAMESPACE}/product`,
    });

    return response.data;
  } catch (e) {
    window.setGlobalAlert('negative', e.message);
  }
};

export default fetchProducts;
