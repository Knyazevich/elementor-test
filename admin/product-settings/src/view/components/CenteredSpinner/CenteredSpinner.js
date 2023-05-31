import styled from '@emotion/styled';
import { Spinner } from '@wordpress/components';

const StyledSpinner = styled(Spinner)`
  position: fixed !important;
  top: 50%;
  left: 50%;
  right: 0;
  bottom: 0;
  width: 50px;
  height: 50px;
`;

function CenteredSpinner() {
  return <StyledSpinner />;
}

export default CenteredSpinner;
