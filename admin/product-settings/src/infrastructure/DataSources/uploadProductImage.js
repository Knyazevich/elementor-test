import { FULL_WP_PATH, isJSON } from './index';

const uploadProductImage = async (productImage) => {
  try {
    const form = new FormData();

    form.append('file', productImage);

    const requestOptions = {
      method: 'POST',
      body: form,
      redirect: 'follow',
      headers: {
        'X-WP-Nonce': window?.restVariables?.nonce,
      },
    };

    const result = await fetch(`${FULL_WP_PATH}/media`, requestOptions);
    const body = await result.json();

    return body?.id;
  } catch (e) {
    window.setGlobalAlert('negative', isJSON(e.message) ? e.message : 'Internal Server Error');
  }
};

export default uploadProductImage;
