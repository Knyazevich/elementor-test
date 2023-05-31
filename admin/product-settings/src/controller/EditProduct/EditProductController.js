import { useEffect, useState } from '@wordpress/element';
import { produce } from 'immer';
import { useLocation, useNavigate } from 'react-router-dom';
import {
  FORM_FIELD_CATEGORY,
  FORM_FIELD_DESCRIPTION, FORM_FIELD_IS_ON_SALE,
  FORM_FIELD_PRICE,
  FORM_FIELD_SALE_PRICE,
  FORM_FIELD_TITLE, FORM_FIELD_YOUTUBE_VIDEO,
} from '../../domain/Product/Product';
import fetchProductCategories from '../../infrastructure/DataSources/fetchProductCategories';
import productCategoriesTransformer from '../../view/transformers/productCategoriesTransformer';
import uploadProductImage from '../../infrastructure/DataSources/uploadProductImage';
import validateProduct from '../validators/validateProduct';
import fetchProductById from '../../infrastructure/DataSources/fetchProductById';
import EditProductView from '../../view/EditProduct/EditProductView';
import updateProduct from '../../infrastructure/DataSources/updateProduct';

function EditProductController() {
  const navigate = useNavigate();
  const location = useLocation();
  const productId = location.search.match(/productId=(\d+)/)[1];

  const [isLoading, setIsLoading] = useState(true);
  const [productCategories, setProductCategories] = useState([]);
  const [productInfo, setProductInfo] = useState({
    [FORM_FIELD_TITLE]: '',
    [FORM_FIELD_DESCRIPTION]: '',
    [FORM_FIELD_PRICE]: 0,
    [FORM_FIELD_SALE_PRICE]: 0,
    [FORM_FIELD_IS_ON_SALE]: false,
    [FORM_FIELD_YOUTUBE_VIDEO]: '',
    [FORM_FIELD_CATEGORY]: 0,
  });

  const [productImage, setProductImage] = useState(null);

  useEffect(() => {
    const fetchData = async () => {
      const fetchedCategories = await fetchProductCategories();
      const fetchedProduct = await fetchProductById(productId);

      setProductCategories(produce(fetchedCategories, (d) => d));
      setProductInfo(produce(fetchedProduct, (d) => d));
      setIsLoading(false);
    };

    fetchData();
  }, []);

  const updateProductField = (field, value) => {
    setProductInfo(produce((d) => {
      d[field] = value;
    }));
  };

  const onSubmitButtonClick = async () => {
    let thumbnailId;

    try {
      await validateProduct(productInfo);
    } catch (e) {
      window.setGlobalAlert('negative', e.message);
      return;
    }

    if (productImage) {
      thumbnailId = await uploadProductImage(productImage);
    }

    if ((productImage && thumbnailId) || !productImage) {
      await updateProduct(productId, productInfo, thumbnailId);

      navigate({ pathname: '/' });

      setTimeout(() => { window.setGlobalAlert('positive', 'Product successfully updated'); }, 1000);
    }
  };

  return (
    <EditProductView
      isLoading={isLoading}
      productCategories={productCategoriesTransformer(productCategories)}
      updateProductField={updateProductField}
      setProductImage={setProductImage}
      onSubmitButtonClick={onSubmitButtonClick}
      productInfo={productInfo}
      productImage={productImage}
    />
  );
}

export default EditProductController;
