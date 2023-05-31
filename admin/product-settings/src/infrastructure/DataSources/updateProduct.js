import apiFetch from '@wordpress/api-fetch';
import { THEME_PATH_NAMESPACE } from './index';

const updateProduct = async (productId, productData, thumbnailId) => {
  try {
    const response = await apiFetch({
      path: `${THEME_PATH_NAMESPACE}/product/${productId}`,
      method: 'PUT',
      data: { data: { ...productData, thumbnailId } },
    });

    return response.data;
  } catch (e) {
    window.setGlobalAlert('negative', e.message);
  }
};

export default updateProduct;
