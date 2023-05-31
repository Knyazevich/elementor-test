import {
  object, string, number, bool,
} from 'yup';
import {
  FORM_FIELD_CATEGORY,
  FORM_FIELD_DESCRIPTION, FORM_FIELD_IS_ON_SALE,
  FORM_FIELD_PRICE,
  FORM_FIELD_SALE_PRICE,
  FORM_FIELD_TITLE, FORM_FIELD_YOUTUBE_VIDEO,
} from '../../domain/Product/Product';

const validateProduct = async (data) => {
  const userSchema = object({
    [FORM_FIELD_TITLE]: string().required(),
    [FORM_FIELD_DESCRIPTION]: string(),
    [FORM_FIELD_PRICE]: number().required().positive(),
    [FORM_FIELD_SALE_PRICE]: number().min(0),
    [FORM_FIELD_IS_ON_SALE]: bool(),
    [FORM_FIELD_YOUTUBE_VIDEO]: string(),
    [FORM_FIELD_CATEGORY]: number(),
  });

  return userSchema.validate(data);
};

export default validateProduct;
