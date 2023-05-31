import { Button } from '@wordpress/components';
import styled from '@emotion/styled';
import PropTypes from 'prop-types';
import { __ } from '@wordpress/i18n';
import Header from '../components/Header/Header';
import Table from '../components/Table/Table';
import CenteredSpinner from '../components/CenteredSpinner/CenteredSpinner';

const StyledHeaderButton = styled(Button)`
  margin-top: 7px;
  margin-left: 10px;
`;

function DashboardView({
  onAddNewButtonClick, tableHeadings, tableData, isLoading,
}) {
  return (
    <>
      {isLoading && <CenteredSpinner />}

      {!isLoading && (
      <div className="wrap">
        <Header title={__('Products', 'twentytwentychild')}>
          <StyledHeaderButton
            isSmall
            variant="secondary"
            onClick={onAddNewButtonClick}
          >
            {__('Add Product', 'twentytwentychild')}
          </StyledHeaderButton>
        </Header>

        <main>
          {tableData.length === 0 && <p>No products found</p>}
          {tableData.length > 0 && <Table columns={tableHeadings} data={tableData} />}
        </main>
      </div>
      )}
    </>
  );
}

DashboardView.propTypes = {
  onAddNewButtonClick: PropTypes.func.isRequired,
  tableHeadings: PropTypes.array.isRequired,
  tableData: PropTypes.array.isRequired,
  isLoading: PropTypes.bool.isRequired,
};

export default DashboardView;
