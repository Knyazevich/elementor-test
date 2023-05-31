import { useState } from '@wordpress/element';
import styled from '@emotion/styled';
import Alert from '../Alert/Alert';

const StyledAlertContainer = styled.div`
  display: ${({ isVisible }) => (isVisible ? 'block' : 'none')};
`;

function GlobalAlert() {
  const [type, setType] = useState(null);
  const [message, setMessage] = useState(null);
  const [isVisible, setIsVisible] = useState(false);

  window.setGlobalAlert = (t, m) => {
    setType(t);
    setMessage(m);
    setIsVisible(true);

    window.scrollTo({
      top: 0,
      behavior: 'smooth',
    });

    setTimeout(() => {
      setIsVisible(false);
    }, 5000);
  };

  return (
    <StyledAlertContainer isVisible={isVisible}>
      <Alert variant={type} scrollIntoView>
        {message}
      </Alert>
    </StyledAlertContainer>
  );
}

export default GlobalAlert;
