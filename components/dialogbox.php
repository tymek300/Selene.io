<style>
/* DIALOG-BOX */
.body-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
}

.dialog-box {
    background-color: #fff;

    margin-top: 20px;

    border-radius: 8px;

    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

    width: 30%;
    min-width: 320px;

    padding: 20px;

    text-align: center;

    position: fixed;
    left: 50%;
    top: 10%;
    
    z-index: 10000;

    transform: translate(-50%);

    overflow-y: scroll;

    max-height: 800px;
}

.dialog-box form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.dialog-box label {
    width: 100%;

    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

.dialog-box span{
    width: 30%;
    min-width: fit-content;

    font-weight: bold;
}

.dialog-box input, .dialog-box textarea, .dialog-box select, .dialog-box fieldset{
    width: 50%;
}

.dialog-box input[type="radio"]
{
    width: fit-content !important;
}

.icon {
    color: #ff6347;

    font-size: 2rem;

    margin-bottom: 15px;
}

.message {
    color: #333;

    font-size: 1rem;

    margin-bottom: 20px;
}

.close-btn {
    background-color: #654ab8;

    border: none;

    color: #fff;

    cursor: pointer;

    padding: 10px 15px;

    border-radius: 5px;
}

.close-btn:hover {
    background-color: #533c99;
}

</style>

<?php

    try
    {
        //Success dialog box with provided message and link to redirect user
        function SuccessMessage($content, $link): void
        {
            ?>
            <div class="body-overlay">
                <div class="dialog-box">
                    <div class="icon">
                        <i class="fa-solid fa-badge-check" style="color: #63E6BE;"></i>
                    </div>
                    <div class="message">
                        <?php
                            echo $content;
                        ?>
                    </div>
                    <button class="close-btn" onclick="closeDialog('<?php echo $link;?>')">Close</button>
                </div>
            </div>
            <?php
        }

        //Failure dialog box with provided message and link to redirect user
        function FailureMessage($content, $link): void
        {
            ?>
                <div class="body-overlay">
                    <div class="dialog-box">
                        <div class="icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="message">
                            <?php
                                echo $content;
                            ?>
                        </div>
                        <button class="close-btn" onclick="closeDialog('<?php echo $link ?>')">Close</button>
                    </div>
                </div>
            <?php
        }

        //Informative dialog box with provided message and link to redirect user
        function InformativeMessage($content, $link): void
        {
            ?>
                <div class="body-overlay">
                    <div class="dialog-box">
                        <div class="icon">
                            <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
                        </div>
                        <div class="message">
                            <?php
                                echo $content;
                            ?>
                        </div>
                        <button class="close-btn" onclick="closeDialog('<?php echo $link ?>')">Close</button>
                    </div>
                </div>
            <?php
        }

        //Fetch request holding
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            // Getting data from JSON request
            $data = json_decode(file_get_contents('php://input'), true);

            //Checking if provided JSON is correct
            if(isset($data['message']) && isset($data['link']))
            {
                $message = $data['message'];
                $link = $data['link'];

                switch($data['type'])
                {
                    case 'success':
                        SuccessMessage($message, $link);
                        break;
                    case 'failure':
                        FailureMessage($message, $link);
                        break;
                    case 'information':
                        InformativeMessage($message, $link);
                        break;
                    default:
                        return;
                }
            }
        }

        //Checking if any communicate is provided in URL. If so displaying it
        if(isset($_GET['communicate']))
        {
            InformativeMessage($_GET['communicate'], $_GET['link']);
        }
        elseif(isset($_GET['success']))
        {
            SuccessMessage($_GET['success'], $_GET['link']);
        }
        elseif(isset($_GET['failure']))
        {
            FailureMessage($_GET['failure'], $_GET['link']);
        }
    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }
    
?>


<script>
//DialogBoxClose
{
	function closeDialog(url)
	{
		window.location.replace(url);
	}
}
</script>