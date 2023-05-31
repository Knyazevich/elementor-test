import apiFetch from '@wordpress/api-fetch';
import { WP_PATH_NAMESPACE } from './index';

const fetchProductCategories = async () => {
  try {
    const categories = await apiFetch({
      path: `${WP_PATH_NAMESPACE}/product_category`,
    });

    if (categories) {
      categories?.map((category) => ({
        id: category.id,
        name: category.name,
      }));
    }

    return categories;
  } catch (e) {
    window.setGlobalAlert('negative', e.message);
  }
};

export default fetchProductCategories;
