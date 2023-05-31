import apiFetch from '@wordpress/api-fetch';
import { THEME_PATH_NAMESPACE } from './index';

const createProduct = async (productData, thumbnailId) => {
  try {
    const response = await apiFetch({
      path: `${THEME_PATH_NAMESPACE}/product/`,
      method: 'POST',
      data: { data: { ...productData, thumbnailId } },
    });

    return response.data;
  } catch (e) {
    window.setGlobalAlert('negative', e.message);
  }
};

export default createProduct;
