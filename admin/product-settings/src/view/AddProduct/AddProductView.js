import { __ } from '@wordpress/i18n';
import {
  Button, CheckboxControl, FormFileUpload,
  Panel, PanelBody, PanelRow, SelectControl, TextareaControl, TextControl,
} from '@wordpress/components';
import styled from '@emotion/styled';
import PropTypes from 'prop-types';
import Header from '../components/Header/Header';
import {
  FORM_FIELD_CATEGORY,
  FORM_FIELD_DESCRIPTION, FORM_FIELD_IS_ON_SALE,
  FORM_FIELD_PRICE,
  FORM_FIELD_SALE_PRICE,
  FORM_FIELD_TITLE, FORM_FIELD_YOUTUBE_VIDEO,
} from '../../domain/Product/Product';
import CenteredSpinner from '../components/CenteredSpinner/CenteredSpinner';

const StyledMain = styled.main`
  .components-base-control {
    width: 100%;
  }
  
  .components-form-file-upload .components-button {
    background: var(--wp-components-color-accent-darker-10, var(--wp-admin-theme-color-darker-10, #006ba1));
    color: var(--wp-components-color-accent-inverted, #fff);
  }
  
  .components-panel {
    margin-bottom: 20px;
  }
`;

const StyledSubmitButton = styled(Button)`
  float: right;
`;

function AddProductView({
  isLoading, productCategories, updateProductField, setProductImage, onSubmitButtonClick, productInfo, productImage,
}) {
  return (
    <>
      {isLoading && <CenteredSpinner />}

      {!isLoading && (
        <div className="wrap">
          <Header title={__('Add New Product', 'twentytwentychild')} />

          <StyledMain>
            <Panel>
              <PanelBody title={__('Product data', 'twentytwentychild')} initialOpen>
                <PanelRow>
                  <TextControl
                    label={__('Title *', 'twentytwentychild')}
                    onChange={(data) => updateProductField(FORM_FIELD_TITLE, data)}
                    value={productInfo[FORM_FIELD_TITLE]}
                  />
                </PanelRow>

                <PanelRow>
                  <TextareaControl
                    label={__('Description', 'twentytwentychild')}
                    onChange={(data) => updateProductField(FORM_FIELD_DESCRIPTION, data)}
                    value={productInfo[FORM_FIELD_DESCRIPTION]}
                  />
                </PanelRow>

                <PanelRow>
                  <TextControl
                    label={__('Price *', 'twentytwentychild')}
                    onChange={(data) => updateProductField(FORM_FIELD_PRICE, data)}
                    value={productInfo[FORM_FIELD_PRICE]}
                  />
                </PanelRow>

                <PanelRow>
                  <TextControl
                    label={__('Sale price', 'twentytwentychild')}
                    onChange={(data) => updateProductField(FORM_FIELD_SALE_PRICE, data)}
                    value={productInfo[FORM_FIELD_SALE_PRICE]}
                  />
                </PanelRow>

                <PanelRow>
                  <CheckboxControl
                    label={__('On sale?', 'twentytwentychild')}
                    value={productInfo[FORM_FIELD_IS_ON_SALE]}
                    onChange={(data) => {
                      updateProductField(FORM_FIELD_IS_ON_SALE, data);
                    }}
                  />
                </PanelRow>

                <PanelRow>
                  <TextControl
                    label={__('Youtube video URL', 'twentytwentychild')}
                    help={__('Make sure that the URL is correct and contains a DESKTOP video id', 'twentytwentychild')}
                    onChange={(data) => updateProductField(FORM_FIELD_YOUTUBE_VIDEO, data)}
                    value={productInfo[FORM_FIELD_YOUTUBE_VIDEO]}
                  />
                </PanelRow>

                <PanelRow>
                  <FormFileUpload
                    accept="image/*"
                    onChange={(event) => setProductImage(event.currentTarget.files[0])}
                    multiple={false}
                    value={productImage}
                  >
                    Upload product image
                  </FormFileUpload>
                </PanelRow>

                <PanelRow>
                  <SelectControl
                    label="Product category"
                    options={productCategories}
                    onChange={(data) => updateProductField(FORM_FIELD_CATEGORY, data)}
                    value={productInfo[FORM_FIELD_CATEGORY]}
                  />
                </PanelRow>
              </PanelBody>
            </Panel>

            <StyledSubmitButton
              isPrimary
              onClick={onSubmitButtonClick}
            >
              { __('Submit', 'twentytwentychild') }
            </StyledSubmitButton>
          </StyledMain>
        </div>
      )}
    </>
  );
}

AddProductView.propTypes = {
  isLoading: PropTypes.bool.isRequired,
  productCategories: PropTypes.array.isRequired,
  updateProductField: PropTypes.func.isRequired,
  setProductImage: PropTypes.func.isRequired,
  onSubmitButtonClick: PropTypes.func.isRequired,
  productInfo: PropTypes.object.isRequired,
  productImage: PropTypes.object,
};

AddProductView.defaultProps = {
  productImage: null,
};

export default AddProductView;
